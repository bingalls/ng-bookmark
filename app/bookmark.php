<?php
require_once '../models/model.php';

/**
 * Copyright 2014 Bruce Ingalls
 * Saves URIs
 *
 * @author bruce.ingall at gmail
 * @copyright (c) 2014, Bruce Ingalls
 */
class Bookmark
{
    private $model;
    private $curPage;
    private $title;
    private $user;

    /**
     * Default constructor
     * @param string $title Default null for current page
     */
    public function __construct($title=null)
    {
        $this->user = filter_input(INPUT_COOKIE, 'bmid', FILTER_SANITIZE_STRING); //must match bookmarks.js
        error_log(__METHOD__ . ":\t" . $this->user);
        $this->model = new BookmarkModel($this->user);
        $this->curPage = filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_URL);
        
        if ($title) {
            $this->title = $title;
        } else {                //set default as current page title
            $matches = array();
            $this->title = "Unknown";
            if (preg_match(
                '/<title>(.+)<\/title>/',
                file_get_contents($this->curPage),
                $matches
                )
                && isset($matches[1])) {
                    $this->title = $matches[1]; 
            }
        }
    }
    
    /**
     * Remove page from database
     * @param string $title Default null for current page
     * @return boolean True on success
     */
    public function delete($title=null)
    {
        if(!$title) {
            $title = $this->title;      //current title
        }
        return $this->model->deleteBookmark($title);
    }

    /**
     * List all your bookmarks
     * @return array Bookmarks(title, url)
     */
    public function get()
    {
        return json_encode($this->model->getBookmarks());
    }
    
    /**
     * Bookmark current page using title & URL
     * @return boolean True on success
     */
    public function set()
    {
        $curUrl = $this->curPage;
        return $this->model->addBookmark($this->title, $curUrl);
    }
    
}
