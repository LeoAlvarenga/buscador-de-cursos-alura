<?php


namespace Alura\BuscadorDeCursos;


use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{

    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {

        $resposta = $this->client->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);

        $elementos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementos as $elemento){
            $cursos[] = $elemento->textContent;
        }

        return $cursos;

    }
}