<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(
        string $containerName,
        Router\RouterInterface $router,
        ?TemplateRendererInterface $template = null
    ) {
        $this->containerName = $containerName;
        $this->router = $router;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->template === null) {
            return new JsonResponse(
                [
                    'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                    'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
                ]
            );
        }

        return new HtmlResponse($this->template->render(
            'app::home-page',
            [
                'containerName' => 'Zend Servicemanager',
                'containerDocs' => 'https://docs.zendframework.com/zend-servicemanager/',
                'routerName' => 'FastRoute',
                'routerDocs' => 'https://github.com/nikic/FastRoute',
                'templateName' => 'Zend View',
                'templateDocs' => 'https://docs.zendframework.com/zend-view/'
            ]
        ));
    }
}
