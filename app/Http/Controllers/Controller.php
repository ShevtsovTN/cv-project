<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="My CV project",
 *      description="API Documentation for CV project",
 *      @OA\Contact(
 *          email="timur.shevtsov1984@gmail.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url="http://localhost/api",
 *      description="API Server"
 * )
 */
abstract class Controller
{
    //
}
