<?php

function modules()
{
    return array(
        '' => array(
            'module' => 'homePage',
            'title' => ''
        ),
        'profile' => array(
            'module' => 'profilePage',
            'title' => 'Perfil'
        ),
        'curso/$1' => array(
            'module' => 'coursePage',
            'title' => 'Curso'
        ),
        '404' => array(
            'module' => '404',
            'title' => 'Erro 404 - Página não encontrada'
        ),
        'cursos/$1' => array(
            'module' => 'coursesList',
            'title' => 'Cursos'
        ),
        'search/$1' => array(
            'module' => 'searchList',
            'title' => 'Pesquisa'
        ),
    );
}