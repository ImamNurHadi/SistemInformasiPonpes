<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Berita;
use Illuminate\Support\Str;

class UpdateBeritaSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-berita-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update slug for all berita records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pembaruan slug berita...');
        
        $beritaCount = Berita::count();
        $bar = $this->output->createProgressBar($beritaCount);
        $bar->start();
        
        Berita::chunk(100, function ($beritas) use ($bar) {
            foreach ($beritas as $berita) {
                $berita->slug = Str::slug($berita->judul);
                $berita->save();
                $bar->advance();
            }
        });
        
        $bar->finish();
        $this->newLine();
        $this->info('Slug berita berhasil diperbarui!');
    }
}
