Symfony media bundle 
====================
This Bundle provides tools to rapidly process image with Symfony

# Instalation

### add package to composer
```
    "symfony-helper/media-bundle": "@dev",
```

### Register bundle in AppKernel
 
```php
    public function registerBundles()
        {
            $bundles = [
                ...
                new SHelper\MediaBundle\SHelperMediaBundle(),
                ...
            ];
    
            ...
            
            return $bundles;
        }
```

# Configuration

### Add configuration config to config.yml

```yml
s_helper_media:
    original_resolution:
        width: 1920
        height: 1080
    previews:
        small:
            width: 32
            height: 32
        thumbnail:
            width: 640
            height: 480
        ... other resolutions

```

Preview section is not required. Parameters `small` and `thumbnail` are only example. You can define custom subsections in preview section.

### Configure Doctrine ORM mapping

```yml
doctrine:
    orm:
        mappings:
            AppBundle:      # this is only example section 
                type: annotation
                prefix: App\Entity
            SHelperMediaBundle:     # Media bundle mapping
                type: annotation
                dir: "Model/Entity"
                prefix: SHelper\MediaBundle\Model\Entity
```


# Usage

Steps:
 - Upload an image and get image ID in response. (Not multipart)
 - Attach this image to you custom entity
 - Enjoy and be happy

Media bundle will create entity `Image`. You must make a unidirectional relation to this `Image` entity. 

### Add an unidirectional relation

```php
/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity
 */
class User implements UserInterface
{
    ...
    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="SHelper\MediaBundle\Model\Entity\Image")
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id", nullable=true)
     */
    private $avatar;
    ...
}
```

### Create image manually

Inject image service to your service.
  
```php
    class YourService
    {
        /** @var IImageService */
        private $imageService;
        
        public function __construct(IImageService $imageService)
        {
            $this->imageService = $imageService;
        }
        ...
        
        public function doSomething()
        {
            $imageBlob = file_get_contents('filename.jpg');
            $image = $this->imageService->createImageFromBlob($imageBlob);
            
            ...
            
            $user->setAvatar($image);
            //OR
            $article->setAvatar($image);
            //OR
            $someThingElse->setAvatar($image);
        }
    }
```
