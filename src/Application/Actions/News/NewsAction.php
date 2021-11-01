<?php
declare(strict_types=1);

/**
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author didier <berliozd@gmail.com>
 * @copyright Copyright (c) 2021 Addeos (http://www.addeos.com)
 */

namespace App\Application\Actions\News;

use App\Application\Actions\Action;
use Goutte\Client;
use Psr\Http\Message\ResponseInterface as Response;

class NewsAction extends Action
{

    protected function action(): Response
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.lemonde.fr');
        $news = [];
        $crawler->filter('div.article > a')->each(function ($node) use (&$news) {
            $url = $node->attr('href');
            $nom = trim($node->filter('.article__title')->text());
            $news[] = ['name' => $nom, 'url' => $url];
        });
        return $this->respondWithData($news);
    }
}
