<?php 

namespace KevinRuscoe\FileTraverser;

class FileTraverser  {

    private $root;

    private $forceDirectoriesAsArray = false;

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
     * Non-sequential keys makes the json encoder turn folders with files as 
     * siblings into objects rather than arays. This sets the files keys as strings,
     * which forces every directory to be an array.
     *
     * @return FileSystem $this
     **/
    public function forceDirectoryAsArray()
    {
        $this->forceDirectoriesAsArray = true;

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
     * @return array|string
     **/
    function traverseDirectory(\DirectoryIterator $directory)
    {
        $data = [];

        foreach ($directory as $item){
            if ($item->isDot()) {
                continue;
            }

            if ($item->isDir()) {
                $data[$item->getFilename()] = $this->traverseDirectory(
                    new \DirectoryIterator($item->getPathname())
                );

                continue;
            }

            if ($this->forceDirectoryAsArray) {
                $data[$item->getFilename()] = $item->getFilename();

                continue;
            }

            $data[] = $item->getFilename();
        }

        return $data;
    }
}