<?php

namespace KevinRuscoe\FileTraverser;

class FileTraverser
{
    /**
     * The root.
     *
     * @var string
     */
    private $root;

    /**
     * A list of directories to ignore.
     *
     * @var array
     */
    private $ignore = [];

    private $formatter;

    /**
     * Builds a new FileTraverse
     *
     * @param string $root
     * @return FileTraverser $this
     **/
    public function __construct($root)
    {
        return $this->setRoot($root);
    }

    /**
     * Sets the root to traverse from.
     *
     * @param string $root
     * @return FileTraverser $this
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
     * @return FileTraverser $this
     **/
    public function ignore($ignore = [])
    {
        $this->ignore = array_merge($this->ignore, $ignore);

        return $this;
    }

    /**
     * Sets the callable to run each node through.
     *
     * @param callable $callable
     * @return FileTraverser $this
     **/
    public function formatNodeAs($formatter)
    {
        $this->formatter = $formatter;

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

        foreach ($directory as $item) {
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

            if ($this->formatter) {
                $data[$item->getFilename()] = call_user_func($this->formatter, $item);

                continue;
            }

            $data[$item->getFilename()] = $item->getFilename();
        }

        return $data;
    }
}
