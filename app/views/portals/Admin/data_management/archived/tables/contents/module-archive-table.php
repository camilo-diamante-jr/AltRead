  <table id="moduleArchiveTable" class="table is-bordered">
      <thead>
          <tr>
              <th style="width: 5%;" class="text-center">#</th>
              <th style="width: 5%;" class="text-center">Select</th>
              <th>Question</th>
          </tr>
      </thead>

      <tbody>
          <?php $index = 1; ?>
          <?php foreach ($pretestArchives as $inActivePretest) : ?>
              <tr>
                  <td class="text-center"><?= $index++; ?></td>
                  <td class="text-center">
                      <input type="checkbox" class="row-checkbox" value="<?= $inActivePretest['pretest_id'] ?>">
                  </td>
                  <td><?= htmlspecialchars($inActivePretest['question']) ?></td>
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>