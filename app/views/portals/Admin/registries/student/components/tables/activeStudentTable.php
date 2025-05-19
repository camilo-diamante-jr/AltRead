  <table id="studentsTable" class="table table-bordered table-hover align-middle">
      <thead class="table-light">
          <tr>
              <th>No.</th>
              <th>Complete Name</th>
              <th>Gender</th>
              <th>Status</th>
              <th>Remarks</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach ($data['learners'] as $index => $student):
                $middleInitial = !empty($student['middle_name']) ? substr($student['middle_name'], 0, 1) . '.' : '';
                $completeName = "{$student['first_name']} $middleInitial {$student['last_name']}";
                $gender = ucfirst($student['sex']);
                $reasonForRejection = $student['reason_for_rejection'] ?? 'N/A';

                // Determine enrollment status
                switch ($student['enrollment_status']) {
                    case "enrolled":
                        $enrollmentStatus = "<span class='badge bg-success'><i class='fas fa-check-circle me-1'></i> Enrolled</span>";
                        break;
                    case "pending":
                        $enrollmentStatus = "<span class='badge bg-info'><i class='fas fa-hourglass-half me-1'></i> Pending</span>";
                        break;
                    case "rejected":
                        $enrollmentStatus = "<span class='badge bg-danger'><i class='fas fa-times-circle me-1'></i> Rejected</span>";
                        break;
                    default:
                        $enrollmentStatus = "<span class='badge bg-warning'><i class='fas fa-exclamation-circle me-1'></i> Error</span>";
                        break;
                }
            ?>
              <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($completeName) ?></td>
                  <td><?= htmlspecialchars($gender) ?></td>
                  <td><?= $enrollmentStatus ?></td>
                  <td class="text-center"><?= htmlspecialchars($reasonForRejection) ?></td>
                  <td>
                      <?php if ($student['enrollment_status'] == "pending" || $student['enrollment_status'] == 'rejected'): ?>
                          <button type="button" class="btn review-btn btn-primary btn-sm"
                              data-bs-toggle="modal" data-bs-target="#reviewFormModal"
                              data-id="<?= htmlspecialchars($student['learner_id']) ?>">
                              <i class="bi bi-eye"></i> Review
                          </button>
                      <?php else: ?>
                          <a href="#" class="text-warning">
                              <i class="fas fa-edit"></i>
                          </a>
                          <a href="#" class="btn btn-danger btn-sm">
                              <i class="fa fa-archive"></i>
                          </a>
                      <?php endif; ?>
                  </td>
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>