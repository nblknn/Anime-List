<?php

declare (strict_types = 1);

class AdminService {
    private const string ROOT_DIR = __DIR__ . '/../view';
    private const string ADMIN_DIR = 'admin';

    public function createFile(string $tempname, string $path): bool {
        return move_uploaded_file($tempname, $path);
    }

    public function createDir(string $path, string $name): bool {
        return mkdir($path . '/' . $name);
    }

    public function deleteDir(string $path): bool {
        foreach (scandir($path) as $file) {
            if ($file !== '.' && $file !== '..') {
                if (is_dir($path . '/' . $file)) {
                    $this->deleteDir($path . '/' . $file);
                } else {
                    $this->deleteFile($path . '/' . $file);
                }
            }
        }
        return rmdir($path);
    }

    public function updateFile(string $file, string $content): bool {
        return file_put_contents($file, $content);
    }

    public function deleteFile(string $file): bool {
        return unlink($file);
    }

    public function renameFile(string $path, string $name): bool {
        $arr = explode('/', $path);
        $arr[count($arr) - 1] = $name;
        return rename($path, implode('/', $arr));
    }

    public function getAllDirFiles(string $dir): array {
        $result = [];
        foreach (scandir($dir) as $file) {
            if ($file !== '.') {
                if (!(realpath($dir) === realpath(self::ROOT_DIR) && ($file === ".." || $file === self::ADMIN_DIR)))
                $result[] = ["name" => $file, "isDir" => is_dir($dir . "/" . $file)];
            }
        }
        return $result;
    }

    public function isFileAnImage(string $path): bool {
        return strtok(mime_content_type($path), '/') === 'image';
    }

    public function getShortPath(string $fullpath): string {
        $fullpath = realpath($fullpath);
        $result = substr($fullpath, strlen(realpath(self::ROOT_DIR)));
        $result = str_replace('\\', '/', $result);
        $result = str_replace('//', '/', $result);
        return $result;
    }

    public function getFullPath(string $path): string {
        $fullpath = realpath(self::ROOT_DIR . '/' . $path);
        $fullpath = str_replace('\\', '/', $fullpath);
        $fullpath = str_replace('//', '/', $fullpath);
        return $fullpath;
    }

    public function getFileName(string $path): string {
        $arr = explode('/', $path);
        return $arr[count($arr) - 1];
    }

    public function getFileContents(string $path): string {
        return htmlspecialchars(file_get_contents($path));
    }
}