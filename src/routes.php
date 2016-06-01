<?php
// Routes

/**
 * @deprecated このコードには脆弱性が含まれているので絶対に使用しないでください
 */

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});

// Level1 普通のReflection XSS
$app->get('/level/1', function ($request, $response, $args) {
    $params = $request->getQueryParams();

    if (isset($params['name'])) {
        $args['getName'] = $params['name'];
    }

    return $this->renderer->render(getUnsafeResponse($response), 'level1.phtml', $args);
});

// Level2 'script'文字列をサニタイズ
$app->get('/level/2', function ($request, $response, $args) {
    $params = $request->getQueryParams();

    if (isset($params['name'])) {
        $args['getName'] = preg_replace('/script/', '', $params['name']);
    }

    return $this->renderer->render(getUnsafeResponse($response), 'level2.phtml', $args);
});

// Level3 '>', '<'文字列をエスケープ
$app->get('/level/3', function ($request, $response, $args) {
    $params = $request->getQueryParams();

    if (isset($params['name'])) {
        $args['getName'] = $params['name'];
    }

    return $this->renderer->render(getUnsafeResponse($response), 'level3.phtml', $args);
});
