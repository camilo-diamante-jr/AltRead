<?php

class SettingsController extends Controller
{
    private $pisModel;
    private $SettingsModel;
    private $validationController;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->pisModel = $this->loadModel('PISModel');
        $this->validationController = new ValidationController($pdo);
        $this->SettingsModel = $this->loadModel('SettingsModel');
    }

    public function fetchAccountSettings()
    {
        checkSession();

        $userId = $_SESSION['user_id'] ?? null;
        $userType = $_SESSION['user_type'] ?? null;

        // Fetch account settings
        $accountSettings = $this->SettingsModel->fetchYourAccountSettings($userId);
        $informationSheet = null; // Initialize to avoid undefined variable errors

        // Check if the user is a learner
        if ($userType === 'Learner') {
            $learnerID = $this->pisModel->fetchLearnersIdByUserId();

            // Validate access
            if (!$this->validationController->validateAccess()) {
                // Redirect or restrict access
                $_SESSION['error_message'] = "You must validate your account before accessing settings.";
                header("Location: /dashboard"); // Redirect to dashboard or another page
                exit();
            }

            $informationSheet = $this->pisModel->showAllLearnersById($learnerID);
        }

        $userSettings = [
            'page_title' => 'Account Settings',
            'brand_text' => $userType,
            'user_account' => $accountSettings,
            'personalInformation' => $informationSheet
        ];

        $this->renderView("/settings/account-settings", $userSettings);

        return $userSettings;
    }
}
