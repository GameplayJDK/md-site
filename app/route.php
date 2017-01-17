<?php

$app->get('/{file:.*}', function ($request, $response, $params)
{

    $file = $params['file'];

    $config = $this->config;

    $converter = $this->converter;
    $renderer = $this->renderer;

    if (empty($file) || $config['overrideDefault'])
    {

        $file = $config['converter']['defaultFileName'];
    }

    if (str_ends_with($file, $config['converter']['fileExtension']))
    {

        $file = substr($file, 0, -strlen($config['converter']['fileExtension']));
    }

    if (!file_exists($config['converter']['baseDirectory'] . $file . $config['converter']['fileExtension']))
    {

        $file = $config['converter']['defaultFileName'];
    }

    $header = ucfirst($file);

    $file = $config['converter']['baseDirectory'] . $file . $config['converter']['fileExtension'];

    $content = file_get_contents($file);

    if ($config['renderer']['prerenderContent'])
    {

        $data = [
            'file' => $file,
            'header' => $header,
            'content' => $content,
            'error' => null,
            'custom_data' => $config['renderer']['customData'],
        ];

        $content = $renderer->render($content, $data);
    }

    if ($request->isXhr() && $config['exposeToXhr'])
    {

        $body = $response->getBody();
        $body->write($content);

        return $response;
    }

    $content = $converter->text($content);

    $data = [
        'file' => $file,
        'header' => $header,
        'content' => $content,
        'error' => null,
        'custom_data' => $config['renderer']['customData'],
    ];

    $file = $config['renderer']['templateFile'];

    $template = file_get_contents($file);
    $template = $renderer->render($template, $data);

    $body = $response->getBody();
    $body->write($template);

    return $response;
});
