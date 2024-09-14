<?php
return [
    // Rotas de autenticação
    'POST /login' => 'login/index',

    // Rotas de Customer
    'POST /customer' => 'customer/create',     // Criação de cliente
    'GET /customer' => 'customer/list',       // Listagem de clientes

    // Documentação Swagger
    'GET /swagger' => 'swagger/json',
];
