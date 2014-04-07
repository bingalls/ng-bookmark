<?php
/**
 * Saves URIs
 *
 * @author bruce.ingall at gmail
 * @copyright (c) 2014, Bruce Ingalls
 */
require_once '../cfg.php';

class BookmarkModel implements BookmarkCfg
{

    private static $db = null;
    private $user;

    /**
     * Open DB connection
     */
    public function __construct($user)
    {
        if (!self::$db) {
            self::$db = new PDO(
                'mysql:host=' . BookmarkCfg::DBHOST . ';dbname=' . BookmarkCfg::DBNAME,
                BookmarkCfg::DBUSER,
                BookmarkCfg::DBPASS
            );
        }
        $this->user = $user;
    }

    /**
     * Return all of your bookmarks
     * @return array Bookmarks
     */
    public function getBookmarks()
    {
        try {
            $sth = self::$db->prepare("SELECT title, uri FROM " . BookmarkCfg::DBPREFIX . "bookmarks WHERE user=?");
            $sth->execute(array($this->user));
            return $sth->fetchAll();
        } catch (PDOExecption $exc) {
            error_log(__METHOD__ . ':' . $exc->getMessage());
        }
    }

    /**
     * Save web page as a bookmark
     *
     * @param string $title HTML title attribute
     * @param string $uri Fully qualified URI
     * @return boolean True on success
     */
    public function addBookmark($title, $uri)
    {
        error_log(__METHOD__ . ":\t" . $this->user);
        try {
            $sth = self::$db->prepare("INSERT INTO " . BookmarkCfg::DBPREFIX . "bookmarks (user, title, uri) VALUES (?, ?, ?)");
            return $sth->execute(array($this->user, $title, $uri));
        } catch (PDOExecption $exc) {
            error_log(__METHOD__ . ':' . $exc->getMessage());
        }
    }

    /**
     * Delete bookmark from database
     *
     * @param string $title HTML title attribute
     * @return boolean True on success
     */
    public function deleteBookmark($title)
    {
        try {
            $sth = self::$db->prepare("DELETE FROM " . BookmarkCfg::DBPREFIX . "bookmarks WHERE user=? AND title=?");
            return $sth->execute(array($this->user, $title));
        } catch (PDOExecption $exc) {
            error_log(__METHOD__ . ':' . $exc->getMessage());
        }
    }

}
