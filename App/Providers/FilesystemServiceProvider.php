<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;

class FilesystemServiceProvider
{
  protected $filesystem;

  public function __construct()
  {
    $this->filesystem = new Filesystem();
  }

  public function getFilesystem()
  {
    return $this->filesystem;
  }
}
