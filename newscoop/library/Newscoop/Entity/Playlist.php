<?php
/**
 * @package Newscoop
 * @copyright 2011 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl.txt
 */
namespace Newscoop\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Playlist entity
 * @ORM\Entity(repositoryClass="Newscoop\Entity\Repository\PlaylistRepository")
 * @ORM\Table(name="playlist")
 */
class Playlist extends Entity
{
	/**
     * @ORM\Id @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id_playlist")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=256, name="name")
     * @var string
     */
    protected $name;

    /**
     * @ORM\oneToMany(targetEntity="Newscoop\Entity\PlaylistArticle", mappedBy="playlist", cascade={"all"})
     */
    private $articles;

    /**
     * Returns the name of the playlist
     */
    public function getName()
	{
		return $this->name;
	}

	/**
     * Returns the name of the playlist
     * @var string $name
     */
    public function setName($name)
	{
	    $this->name = $name;
		return $this;
	}
}
