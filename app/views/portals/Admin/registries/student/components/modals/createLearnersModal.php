<div class="modal fade" id="addNewLearnerModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">
                    <strong>PERSONAL INFORMATION SHEET</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto" style="max-height: 70vh; padding: 20px;">

                <!-- Form Section -->
                <section class="my-4">
                    <form action="" class="mt-4">
                        <p class="fw-bold">A. Answer the following.</p>
                        <ol>
                            <!-- 1 -->
                            <li class="mb-2">What is your complete name?</li>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="First Name" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Middle Name" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Last Name" />
                                </div>
                            </div>

                            <!-- 2 -->
                            <li class="mb-2">What is your sex? Check(&#10003;) the corresponding box.</li>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="male" id="male" />
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="female" id="female" />
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <!-- 3 -->
                            <li class="mb-2">When is your birthday?</li>
                            <input type="date" class="form-control">

                            <!-- 4 -->
                            <li class="mb-2">Where do you live?</li>
                            <input type="text" class="form-control mb-3" placeholder="House number/Street, Barangay, City/Town, Province" />

                            <!-- 5 -->
                            <li class="mb-2">What is your religion?</li>
                            <input type="text" class="form-control mb-3" placeholder="Religion" />

                            <!-- 6 -->
                            <li class="mb-2">What is your marital status?</li>
                            <select name="marital-status" id="marital-status" class="form-select mb-3">
                                <option selected disabled>Select Marital Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widow/Widower">Widow/Widower</option>
                                <option value="Separated/Divorced">Separated/Divorced</option>
                            </select>

                            <!-- 7 -->
                            <li class="mb-2">What is your job/occupation?</li>
                            <input type="text" class="form-control mb-3" placeholder="Occupation" />

                            <!-- 8 -->
                            <li class="mb-2">What is your educational attainment?</li>
                            <input type="text" class="form-control mb-3" placeholder="Educational Attainment" />
                        </ol>

                        <!-- Section B -->
                        <p class="fw-bold mt-4">
                            B. Write a paragraph (2-3 sentences) about yourself, including your interests and ambitions.
                        </p>
                        <textarea class="form-control mb-4" rows="4" placeholder="Write here..."></textarea>
                    </form>
                </section>

                <!-- Footer -->
                <div class="d-flex justify-content-between fw-bold">
                    <p class="mb-0">10 |FLT Junior High School</p>
                    <p class="mb-0">2019</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>