<?php

require_once '../core/Controller.php';

class ArchiveController extends Controller
{
    // private  $archiveModel;
    private  $materialsController;
    private $pretestModel;
    public function __construct($pdo)
    {

        parent::__construct($pdo);
        $this->materialsController = new MaterialsController($pdo);
        $this->pretestModel = $this->loadModel('PretestModel');
        // $this->archiveModel = $this->loadModel('ArchiveModel');
    }

    public function archiveFunction()
    {


        // $archivedUsers = $this->materialsController->showAllArchivedMaterials();
        $archivedMaterials = $this->materialsController->showAllArchivedMaterials();
        $inActivePretest = $this->pretestModel->getAllArhcivePretest();

        $data = [
            'page_title' => 'Admin | Archives',
            'breadcrumb_title' => 'Manage Archives',
            'breadcrumb_go_back_home_text' => 'Home',
            'breadcrumb_current_link_text' => 'Archives',
            'footer' => "AltRead",

            'MaterialArchives' => $archivedMaterials,
            'pretestArchives' => $inActivePretest,
        ];


        $this->renderView('pages/Admin/data_management/archived/main-archive', $data);
    }

    public function restoreFunction()
    {
        $dbRow = $_POST['filterDB']; // Get the selected filter (e.g., pretest, materials, etc.)
        $selectedIDs = $_POST['selectedIDs']; // Get selected row IDs

        if (!empty($selectedIDs)) {
            foreach ($selectedIDs as $id) {
                if ($dbRow === "pretest") {
                    // Restore Pretest
                    // Example Query: UPDATE pretests SET status = 'active' WHERE pretest_id = $id;
                } elseif ($dbRow === "materials") {
                    // Restore Materials
                    // Example Query: UPDATE materials SET status = 'active' WHERE material_id = $id;
                }
                // Add other cases if needed
            }
            echo json_encode(["success" => true, "message" => ucfirst($dbRow) . " restored successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "No items selected for restoration."]);
        }
    }
}
