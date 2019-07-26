<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class scrapePreciosa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:preciosa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the preciosa rocailles beads';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //the preciosa url - this places all beads on a single page
        $preciosaURL = 'https://preciosa-ornela.com/catalog/en/13-rocailles';
        $pagnationURL = 'https://preciosa-ornela.com/catalog/modules/blocklayered/blocklayered-ajax.php?id_category_layered=13&orderby=name&orderway=asc&n=20&p=';

        $crawler = \Goutte::request('GET', $preciosaURL);

        //get the total number of beads to show
        $beadsTotal = $crawler->filter('.heading-counter')->text();
        $beadsTotal = preg_replace('/[^0-9]/', '', $beadsTotal);

        $form = $crawler->selectButton('Show all')->form();
        $crawler = \Goutte::submit($form, ['id_category' => 13, 'n' => $beadsTotal]);

        //get an array of all the links to the individual bead pages
        $allLinks = $crawler->filter(" div.button-container > a")
            ->each(function ($node)  {
                return $node->attr('href');
            });

        dd($allLinks);


    }
}
