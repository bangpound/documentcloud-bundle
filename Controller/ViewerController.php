<?php

namespace Bangpound\Bundle\DocumentCloudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bangpound\Bundle\DocumentCloudBundle\Entity\Document;
use Bangpound\Bundle\DocumentCloudBundle\Model\SearchResult;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ViewerController
 * @package Bangpound\Bundle\DocumentCloudBundle\Controller
 */
class ViewerController extends Controller
{
    /**
     * @param  Document     $document
     * @return JsonResponse
     */
    public function documentAction(Document $document)
    {
        $id = $document->getId();
        $pathname = $document->getAbsolutePath();

        $driver = $this->get('bangpound_documentcloud.binary_driver.docsplit');

        $length = $driver->command(array('length', $pathname));
        $title = trim($driver->command(array('title', $pathname)));
        $description = trim($driver->command(array('subject', $pathname)));

        $document->setTitle($title);
        $document->setDescription($description);
        $document->setPages((int) $length);
        $document->setId(rawurlencode($id));

        $text_route = 'bangpound_documentcloud_viewer_page_text';
        $image_route = 'bangpound_documentcloud_viewer_page_image';
        $text_parameters = array(
            'id' => $id,
            '_format' => 'txt',
            'page' => '{page}',
        );

        $image_parameters = array(
            'id' => $id,
            '_format' => 'png',
            'size' => '{size}',
            'page' => '{page}',
        );

        $document->setResource('page', array(
            'text' => strtr($this->generateUrl($text_route, $text_parameters), array('%7B' => '{', '%7D' => '}')),
            'image' => strtr($this->generateUrl($image_route, $image_parameters), array('%7B' => '{', '%7D' => '}')),
        ));
        $document->setResource('search', $this->generateUrl('bangpound_documentcloud_viewer_search', array('id' => $id, '_format' => 'json')) .'?{query}');

        return new JsonResponse($document);
    }

    /**
     * @param  Request           $request
     * @param  Document          $document
     * @param  int               $page
     * @throws \RuntimeException
     * @return mixed
     */
    public function pageTextAction(Request $request, Document $document, $page)
    {
        $destination = $this->container->getParameter('kernel.root_dir') .'/../web'. $request->getPathInfo();

        $driver = $this->get('bangpound_documentcloud.binary_driver.pdftotext');
        $filesystem = $this->get('filesystem');
        $filesystem->mkdir(dirname($destination));

        $builder = $driver->getProcessBuilderFactory();
        $process = $builder->create(array('-raw', $document->getAbsolutePath(), '-'));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
        $output = $process->getOutput();
        $full_text = explode(chr(12), trim($output, chr(12)));

        file_put_contents($destination, $full_text[$page - 1]);

        return BinaryFileResponse::create($destination);
    }

    /**
     * @param  Request           $request
     * @param  Document          $document
     * @param  int               $page
     * @param  string            $size
     * @throws \RuntimeException
     * @return Response
     */
    public function pageImageAction(Request $request, Document $document, $page, $size)
    {
        $sizes = ['small' => 180, 'normal' => 700, 'large' => 1000];
        $width = $sizes[$size];

        $destination = $this->container->getParameter('kernel.root_dir') .'/../web'. $request->getPathInfo();

        $driver = $this->get('bangpound_documentcloud.binary_driver.graphicsmagick');
        $filesystem = $this->get('filesystem');
        $filesystem->mkdir(dirname($destination));

        $arguments = array('convert', '+adjoin', '-define', 'pdf:use-cropbox=true',
            '-limit', 'memory', '256MiB', '-limit', 'map', '512MiB', '-density', '150',
            '-resize', $width .'x', '-quality', 100,
            $document->getAbsolutePath().'['.($page - 1). ']', $destination);

        $builder = $driver->getProcessBuilderFactory();
        $process = $builder->create($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return BinaryFileResponse::create($destination);
    }

    /**
     * @param  Request      $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        /** @var \Elasticsearch\Client $es */
        $client = $this->get('es.client');

        $query_string = rawurldecode($request->getQueryString());

        $document = $request->attributes->get('document');

        $params = [
            'index' => 'investments',
            'type' => 'page',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    '_parent' => $document['_id'],
                                ],
                            ],
                            [
                                'query_string' => [
                                    'query' => $query_string,
                                ],
                            ],
                        ],
                    ],
                ],
                'size' => pow(2,16),
                'fields' => ['page'],
            ],
        ];

        $ret = $client->search($params);

        $results = array();
        foreach ($ret['hits']['hits'] as $hit) {
            $results[] = $hit['fields']['page'];
        }

        $result = new SearchResult();
        $result->setQuery($query_string);
        $result->setMatches($ret['hits']['total']);
        $result->setResults($results);

        return new JsonResponse($result);
    }
}
