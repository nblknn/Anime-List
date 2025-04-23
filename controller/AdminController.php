<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../service/AdminService.php';
require_once __DIR__ . '/../model/FileType.php';
require_once __DIR__ . '/../TemplateEngine.php';

class AdminController extends BaseController {
    private const string DIR_TEMPLATE = __DIR__ . '/../view/admin/html/dircontents.html';
    private const string IMAGE_TEMPLATE = __DIR__ . '/../view/admin/html/imagefilecontents.html';
    private const string FILE_TEMPLATE = __DIR__ . '/../view/admin/html/textfilecontents.html';
    private AdminService $service;
    private TemplateEngine $templateEngine;

    public function __construct() {
        $this->service = new AdminService();
        $this->templateEngine = new TemplateEngine();
    }

    public function getFileAction(): string {
        $fullPath = $this->service->getFullPath(($_GET["path"] ?? ""));
        if (!$fullPath || !$this->service->isAllowedPath($fullPath))
            return "404 Not Found";
        $path = $this->service->getShortPath($fullPath);
        return match($this->service->getFileType($fullPath)) {
            FileType::Dir => $this->templateEngine->render(self::DIR_TEMPLATE,
                ["dir" => $this->service->getAllDirFiles($fullPath), "path" => $path . "/", "dirname" => $this->service->getFileName($path)]),
            FileType::Image => $this->templateEngine->render(self::IMAGE_TEMPLATE,
                ["file" => '/view/' . $path, "path" => $path,"filename" => $this->service->getFileName($path)]),
            FileType::File =>$this->templateEngine->render(self::FILE_TEMPLATE,
                ["file" => $this->service->getFileContents($fullPath), "path" => $path, "filename" => $this->service->getFileName($path)])
        };
    }

    public function defaultAction(): string {
        return $this->getFileAction();
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