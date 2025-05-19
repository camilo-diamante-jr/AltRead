  <!-- Navbar -->
  <nav class="app-header navbar navbar-expand bg-body sticky-top">
      <div class="container-fluid">
          <!-- Start Navbar Links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                      <i class="bi bi-list"></i>
                  </a>
              </li>
          </ul>

          <!-- User Info and Dropdown -->
          <ul class="navbar-nav ms-auto">
              <!-- <li class="nav-item dropdown">
                  <a class="nav-link" data-bs-toggle="dropdown" href="#">
                      <i class="bi bi-chat-text"></i>
                      <span class="navbar-badge badge text-bg-danger">3</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                      <a href="#" class="dropdown-item">
                          <div class="d-flex">
                              <div class="flex-shrink-0">
                                  <img src="../../dist/assets/img/user1-128x128.jpg" alt="User Avatar"
                                      class="img-size-50 rounded-circle me-3">
                              </div>
                              <div class="flex-grow-1">
                                  <h3 class="dropdown-item-title">
                                      Brad Diesel
                                      <span class="float-end fs-7 text-danger"><i
                                              class="bi bi-star-fill"></i></span>
                                  </h3>
                                  <p class="fs-7">Call me whenever you can...</p>
                                  <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hours
                                      Ago</p>
                              </div>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                  </div>
              </li> -->

              <li class="nav-item">
                  <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                      <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                      <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                  </a>
              </li>

              <li class="dropdown">
                  <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="../../files/uploads/avatars/<?= htmlspecialchars($userProfile['avatar']); ?>"
                          class="user-image rounded-circle shadow" alt="User Image" width="32" height="32">
                      <span
                          class="d-none d-md-inline fw-bold capitalize"><?= htmlspecialchars($userProfile['username']); ?></span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                      <li>
                          <a class="dropdown-item" href="#">
                              <i class="fas fa-sliders-h fa-fw me-2"></i>
                              <span>Account</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="#">
                              <i class="fas fa-gear fw-bold me-2"></i>
                              <span>Settings</span>
                          </a>
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
                      <li>
                          <a class="dropdown-item" href="/logout"><i
                                  class="fas fa-sign-out-alt fa-fw me-2"></i>
                              <span>Log Out</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </nav>