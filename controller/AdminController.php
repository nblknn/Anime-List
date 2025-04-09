<?php

declare (strict_types = 1);

require_once __DIR__ . '/../service/AdminService.php';
require_once __DIR__ . '/../TemplateEngine.php';

class AdminController {
    private AdminService $service;
    private TemplateEngine $templateEngine;

    public function __construct() {
        $this->service = new AdminService();
        $this->templateEngine = new TemplateEngine();
    }

    public function getFileAction(): string {
        $fullPath = $this->service->getFullPath(($_GET["path"] ?? ""));
        $path = $this->service->getShortPath($fullPath);
        if (!file_exists($fullPath))
            return "404 Not Found";
        if (is_dir($fullPath))
            return $this->templateEngine->render(__DIR__ . '/../view/admin/html/dircontents.html',
                array("dir" => $this->service->getAllDirFiles($fullPath), "path" => $path . "/", "dirname" => $this->service->getFileName($path)));
        else if ($this->service->isFileAnImage($fullPath))
            return $this->templateEngine->render(__DIR__ . '/../view/admin/html/imagefilecontents.html',
                array("file" => '/view/' . $path, "path" => $path, "filename" => $this->service->getFileName($path)));
        else
            return $this->templateEngine->render(__DIR__ . '/../view/admin/html/textfilecontents.html',
                array("file" => $this->service->getFileContents($fullPath), "path" => $path, "filename" => $this->service->getFileName($path)));
    }

    public function handleAction(bool $result, string $errorMessage): string {
        if ($result) {
            return json_encode([
                'success' => true,
            ]);
        }
        else {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'error' => $errorMessage,
            ]);
        }
    }

    public function addFileAction(): string {
        return $this->handleAction(($this->service->createFile($_FILES["file"]["tmp_name"],
            $this->service->getFullPath(($_GET["path"] ?? "")) . '/' . $_FILES["file"]["name"])),
            "Ошибка при добавлении файла");
    }

    public function deleteFileAction(): string {
        return $this->handleAction($this->service->deleteFile($this->service->getFullPath(($_GET["path"] ?? ""))),
            "Ошибка при удалении файла");
    }

    public function deleteDirAction(): string {
        return $this->handleAction($this->service->deleteDir($this->service->getFullPath(($_GET["path"] ?? ""))),
            "Ошибка при удалении папки");
    }

    public function updateFileAction(): string {
        return $this->handleAction($this->service->updateFile($this->service->getFullPath(($_GET["path"] ?? "")),
            $_POST["file"]), "Ошибка при обновлении файла");
    }

    public function renameFileAction(): string {
        return $this->handleAction($this->service->renameFile($this->service->getFullPath(($_GET["path"] ?? "")),
            $_POST["name"]), "Ошибка при переименовании файла");
    }

    public function addDirAction(): string {
        return $this->handleAction($this->service->createDir($this->service->getFullPath(($_GET["path"] ?? "")),
            $_POST["name"]), "Ошибка при создании папки");
    }
}