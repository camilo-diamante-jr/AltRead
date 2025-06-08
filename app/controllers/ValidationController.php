<?php

require_once '../core/Controller.php';

class ValidationController extends Controller
{
    private  $pisController;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->pisController = new PISController($pdo);
    }

    /**
     * Validate user access based on session and enrollment status.
     * 
     * @return bool Returns true if access is valid; otherwise, handles unauthorized access and returns false.
     */
    public function validateAccess(): bool
    {
        $userID = $_SESSION['user_id'] ?? null;

        if (!$userID) {
            $this->handleUnauthorizedAccess('unauthorized');
            return false;
        }

        $status = $this->pisController->fetchEnrollmentStatus($userID);

        if ($status !== "enrolled") {
            $this->handleUnauthorizedAccess($status ?? 'unknown');
            return false;
        }

        return true;
    }

    /**
     * Handle unauthorized access by redirecting or showing a message.
     * 
     * @param string $status The enrollment status or reason for unauthorized access.
     */
    private function handleUnauthorizedAccess(string $status): void
    {
        $brandText = 'Student Portal';
        $message = '';
        $title = '';

        $registryComponents = 'portals/Student/registries/components/';

        switch ($status) {
            case "pending":
                $view = $registryComponents . 'pis_is_pending';
                $message = 'Your PIS is still pending for approval.';
                $title = "PIS - Pending";
                break;
            case "rejected":
                $view = $registryComponents . 'pis_has_been_rejected';
                $message = 'Your PIS has been rejected. Please review and resubmit.';
                $title = "PIS - Rejected";
                break;
            case "unauthorized":
                $view = 'portals/unauthorized';
                $message = 'You are not authorized to access this page.';
                $title = "Unauthorized Access";
                break;
            default:
                $view = 'portals/Student/registries/view.personal.info';
                $message = 'Please complete your Personal Information Sheet to proceed.';
                $title = "Personal Information Sheet";
        }

        error_log("Unauthorized access: $status");

        $data = [
            'message' => $message,
            'brand_text' => $brandText,
            'page_title' => $title,
        ];

        // Prevent further script execution after unauthorized access
        $this->renderView($view, $data);
        exit(); // Stop further execution
    }
}
