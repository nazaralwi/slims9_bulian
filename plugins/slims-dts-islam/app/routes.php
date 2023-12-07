<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 26/06/2021 0:57
 * @File name           : routes.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

use DTSIslam\App\Controllers\BiblioTopicController;
use DTSIslam\App\Controllers\SubjectController;
use DTSIslam\App\Controllers\WelcomeController;

// create new router instance
$router = new \DTSIslam\Lib\Router();

// register routes
$router->get('/', [WelcomeController::class, 'index']);
$router->get('/merge', [SubjectController::class, 'merge']);
$router->get('/topic/count', [SubjectController::class, 'topicCount']);
$router->get('/topic/our/count', [SubjectController::class, 'ourTopicCount']);
$router->post('/topic/doMerge', [SubjectController::class, 'doMerge']);

$router->get('/use', [SubjectController::class, 'use']);
$router->get('/biblio/topic/count', [BiblioTopicController::class, 'getBiblioTopicCount']);
$router->post('/biblio/topic/migrate', [BiblioTopicController::class, 'doMigrate']);

$router->get('/drop', [SubjectController::class, 'drop']);
$router->get('/credits', [WelcomeController::class, 'credits']);

// run router
$router->run();
