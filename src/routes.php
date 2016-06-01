<?php
// Routes

/**
 * @deprecated このコードには脆弱性が含まれているので絶対に使用しないでください
 */

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});

// 普通のReflection XSS
$app->get('/level/1', function ($request, $response, $args) {
    $params = $request->getQueryParams();

    // level1ではgetパラメータを付与
    if (isset($params['name'])) {
        $args['getName'] = $params['name'];
    }

    $unsafeResponse = $response->withHeader('x-xss-protection', '0');

    return $this->renderer->render($unsafeResponse, 'level1.phtml', $args);
});
