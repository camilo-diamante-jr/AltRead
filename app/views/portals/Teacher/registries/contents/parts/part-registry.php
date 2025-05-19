   <!-- Add Parts Button -->
   <div class="d-flex justify-content-between mb-3">
       <h5 class="mb-0">Parts</h5>
       <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">
           <i class="fa fa-plus"></i> Add Parts
       </button>
   </div>


   <div class="table-responsive">
       <table id="moduleTbl" class="table table-hover table-bordered" id="modulesTable">
           <thead>
               <tr>
                   <th>Part name</th>
                   <th>Actions</th>
               </tr>
           </thead>
           <tbody>
               <?php foreach ($parts as $index => $part): ?>
                   <tr>
                       <td><?= htmlspecialchars($part["part_name"]); ?></td>
                       <td style="width:10%">
                           <div class="btn-group">
                               <button class="btn btn-sm edit btn-warning">
                                   <i class="fa fa-pencil" aria-hidden="true"></i>
                               </button>
                               <button class="btn btn-sm delete btn-danger">
                                   <i class="fa fa-trash" aria-hidden="true"></i>
                               </button>
                           </div>
                       </td>
                   </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
   </div>