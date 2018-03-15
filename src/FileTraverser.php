<?php

namespace KevinRuscoe\FileTraverser;

class FileTraverser  {

    private $root;

    private $ignore;

    /**
     * __construct
     *
     * @param string $root
     * @return FileSystem $this
     **/
    function __construct($root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Sets the root to traverse from.
     *
     * @param string $root
     * @return FileSystem $this
     **/
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Sets the ignore list.
     *
     * @param array $ignore
     * @return FileSystem $this
     **/
    public function ignore($ignore = [])
    {
        $this->ignore = array_merge($this->ignore, $ignore);

        return $this;
    }

    /**
     * Builds a tree of directories and files.
     *
     * @return array $structure
     **/
    public function getStructure()
    {
        if (is_null($this->root)) {
            throw new \ArgumentCountError('A root is needed to traverse from.');
        }

        return $this->traverseDirectory(
            new \DirectoryIterator($this->root)
        );
    }

    /**
     * Sets the root to traverse from
     *
     * @param DirectoryIterator $directory
     * @return array $data
     **/
    private function traverseDirectory(\DirectoryIterator $directory)
    {
        $data = [];

        foreach ($directory as $item){
            if ($item->isDot()) {
                continue;
            }

            if ($this->ignore) {
                if (in_array($item->getFilename(), $this->ignore)) {
                    continue;
                }
            }

            if ($item->isDir()) {
                $data[$item->getFilename()] = $this->traverseDirectory(
                    new \DirectoryIterator($item->getPathname())
                );

                continue;
            }

            $data[$item->getFilename()] = $item->getFilename();
        }

        return $data;
    }
}
