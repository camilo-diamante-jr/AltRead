<div class="row justify-content-center">
    <?php if (empty($quizzes)) : ?>

        <div
            class="alert alert-info alert-dismissible fade show"
            role="alert">

            <strong>Notice!</strong> No personalize quizzes available. Please try again later.
        </div>


        <?php else : foreach ($quizzes  as $quiz) :  ?>

            <div class="mt-3 d-flex align-items-center justify-content-center gap-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i>
                        <!-- Previous -->
                    </button>
                    <button type="button" class="btn btn-sm btn-success">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <button type="submit" class="btn btn-sm btn-primary d-none">Submit</button>

            </div>

    <?php
        endforeach;
    endif;
    ?>
</div>