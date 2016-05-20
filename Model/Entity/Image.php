<?php
namespace SHelper\MediaBundle\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SHelper\MediaBundle\Model\Repository\ImageRepository")
 * @ORM\Table(name="app_media_image")
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @var array|string[]
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $preview;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array|\string[]
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param array|\string[] $preview
     * @return $this
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }
}
