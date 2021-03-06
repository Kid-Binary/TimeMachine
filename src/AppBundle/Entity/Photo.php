<?php
// src/AppBundle/Entity/Photo.php
namespace AppBundle\Entity;

use DateTime;

use Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapper,
    AppBundle\Entity\Utility\Traits\DoctrineMapping\TranslationMapper,
    AppBundle\Entity\Utility\Traits\DoctrineMapping\SortableMapper,
    AppBundle\Entity\Utility\Traits\TagTrait,
    AppBundle\Entity\Utility\Interfaces\PhotoConstantsInterface,
    AppBundle\Entity\Utility\Traits\FileObjects\PhotoFileObjectsTrait;

/**
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PhotoRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\PhotoTranslation")
 *
 * @Vich\Uploadable
 */
class Photo implements Translatable, PhotoConstantsInterface
{
    use IdMapper, TranslationMapper, SortableMapper, TagTrait, PhotoFileObjectsTrait;

    /**
     * @ORM\OneToMany(targetEntity="PhotoTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="photos")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $tags;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="PhotoAlbum", inversedBy="photos")
     * @ORM\JoinColumn(name="photo_album_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $photoAlbum;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="date")
     */
    protected $dateTaken;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isCover = FALSE;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection;
    }

    /**
     * To string
     */
    public function __toString()
    {
        return ( $this->title ) ?: "Фотография";
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Photo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set dateTaken
     *
     * @param \DateTime $dateTaken
     * @return Photo
     */
    public function setDateTaken($dateTaken)
    {
        $this->dateTaken = $dateTaken;

        return $this;
    }

    /**
     * Get dateTaken
     *
     * @return \DateTime
     */
    public function getDateTaken()
    {
        return $this->dateTaken;
    }

    /**
     * Set isCover
     *
     * @param boolean $isCover
     * @return Photo
     */
    public function setIsCover($isCover)
    {
        $this->isCover = $isCover;

        return $this;
    }

    /**
     * Get isCover
     *
     * @return boolean
     */
    public function getIsCover()
    {
        return $this->isCover;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     * @return Photo
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set photoAlbum
     *
     * @param \AppBundle\Entity\PhotoAlbum $photoAlbum
     * @return Photo
     */
    public function setPhotoAlbum(\AppBundle\Entity\PhotoAlbum $photoAlbum = null)
    {
        $this->photoAlbum = $photoAlbum;

        return $this;
    }

    /**
     * Get photoAlbum
     *
     * @return \AppBundle\Entity\PhotoAlbum
     */
    public function getPhotoAlbum()
    {
        return $this->photoAlbum;
    }
}
