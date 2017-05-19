<?php

namespace dolphiq\twighelpers\twigextensions;

use dolphiq\twighelpers\TwigHelpers;

use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class LaravelMixTwigExtension extends Twig_Extension
{

    static $manifestObject = null;
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'LaravelMix';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('laravelMix', [$this, 'laravelMix']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('laravelMix', [$this, 'laravelMix']),
        ];
    }


    /**
     * Locate manifest and convert to an array.
     *
     * @return array|bool
     */
    protected function readManifestFile()
    {
        $manifestFile = $this->manifest = join(DIRECTORY_SEPARATOR, [
            CRAFT_BASE_PATH,
            'mix-manifest.json'
        ]);
        if (file_exists($manifestFile)) {
            return json_decode(
                file_get_contents($manifestFile),
                true
            );
        }

        return false;
    }

    protected function getVersionedAsset($file)
    {
        // please get the .json file and store it to the class static
        if (self::$manifestObject == null) {
          self::$manifestObject = $this->readManifestFile();
        }
        $publicPath = DIRECTORY_SEPARATOR . 'web' ;

        if(self::$manifestObject === false) {
          return $file;
        }
        // check if the asset exists in the object

        $versionedFile=self::$manifestObject[$publicPath . $file];
        if($versionedFile) {
          // please strip the $publicPath part
          $versionedFile=substr($versionedFile, strlen($publicPath));
          return $versionedFile;
        } else
        {
          return $file;
        }
    }


    /**
     * Returns versioned file or the entire tag.
     *
     * @param  string  $file
     * @param  bool  $tag  (optional)
     * @param  bool  $inline  (optional)
     * @return string
     */
    public function laravelMix($file)
    {
        return $this->getVersionedAsset($file);
    }
}
