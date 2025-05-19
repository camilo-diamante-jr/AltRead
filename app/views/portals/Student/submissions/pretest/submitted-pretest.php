<table
   id="pretestSubmittedTable"
   class="table table-striped table-bordered align-middle mb-0">
   <thead class="table-light">
      <tr>
         <th>#</th>
         <th>Questions</th>
         <th>Type</th>
         <th>Scores</th>
         <th class="no-sort">Actions</th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($pretest_submissions as $index => $pretest_submission) : ?>
         <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $pretest_submission['question'] ?></td>
            <td><?= $pretest_submission['pretest_type'] ?></td>
            <td><?= $pretest_submission['pretestScore'] ?></td>
            <td>
               <a href="#" class="me-2" title="View">
                  <i class="fa fa-eye text-primary fs-5"></i>
               </a>
               <a href="#" class="me-2" title="Edit">
                  <i class="fa fa-pencil text-warning fs-5"></i>
               </a>
               <a href="#" class="me-2" title="Archive">
                  <i class="fa fa-archive text-secondary fs-5"></i>
               </a>
            </td>
         </tr>
      <?php endforeach; ?>

   </tbody>
</table>