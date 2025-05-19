 <section id="firstPart" class="">
     <h5 class="fw-bold text-center"> TRYING THIS OUT </h5>
     <div class="card custom-card m-auto p-4">

         <h5 class="mb-4">
             <strong>Directions: </strong>Select the best answer by clicking on the radio buttons below.
         </h5>

         <p><?= $question['lesson_id'] ?></p>

         <!-- Main Idea Section -->
         <div class="mb-4">
             <p class="fw-bold">A. The main idea of a paragraph: <span class="mainIdeaBlank">________</span></p>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="main_idea" id="option1">
                 <label class="form-check-label" for="option1">is the most important point of a text</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="main_idea" id="option2">
                 <label class="form-check-label" for="option2">is the least important point of a text</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="main_idea" id="option3">
                 <label class="form-check-label" for="option3">may be found in the title of the text</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="main_idea" id="option4">
                 <label class="form-check-label" for="option4">may be found as part of an introduction to a text</label>
             </div>
         </div>
         <div class="mb-4">
             <p class="fw-bold">B. The supporting details: <span class="supportingDetailsBlank">________</span></p>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="supporting_details" id="support1">
                 <label class="form-check-label" for="support1">support the main idea</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="supporting_details" id="support2">
                 <label class="form-check-label" for="support2">support other supporting details</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="supporting_details" id="support3">
                 <label class="form-check-label" for="support3">have exactly the same meaning as the main idea</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="supporting_details" id="support4">
                 <label class="form-check-label" for="support4">may be found in additional data</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="supporting_details" id="support5">
                 <label class="form-check-label" for="support5">may be found in further description</label>
             </div>
         </div>
     </div>
     <!-- Supporting Details Section -->


 </section>

 <section id="secondPart" class="d-none">
     <h3 class="fw-bold text-uppercase text-center">Understanding What You Did</h3>
     <div class="custom-card mx-auto">
         <h5 class="custom-title">Why Snakes Shed Skin</h5>
         <p class=""><strong>Directions:</strong> Read the following paragraph. Notice how the
             paragraph is analyzed in order to identify the main idea and its
             supporting details.</p>
         <img src="assets/images/snake.jpg" alt="Snake shedding skin" class="shadow custom-image">
         <p class="custom-text mt-3">
             Snakes shed their skin to allow for further growth. The top layer of a snake’s skin doesn’t grow,
             but its body does. So as a snake gets bigger, it has to get rid of the top layer and leaves it behind.
             They scrape their bodies against rocks, trees, and the ground until they can slither out of their old skin.
         </p>
     </div>
 </section>

 <section id="thirdPart" class="d-none">
     <h3 class="text-center text-uppercase fw-bold">Sharpening Your Skills</h3>
     <div class="">

         <div class="card custom-card m-auto p-3 mb-3">
             <p class=""><strong>Directions:</strong> Identify the main idea and at least three of its supporting details in
                 the paragraphs below. Write your answers below the paragraphs.
             </p>
             <img src="assets/images/planting.png" alt="" class="custom-image">
             <p class="mt-3">
                 Gina loves Sundays. In the morning, she goes out of the house to
                 check her plants. It makes her happy to see how they grow day by
                 day. She also spends time to play with her dogs. She is so busy from
                 Monday until Saturday that she can only have time for them on
                 Sundays. After playing with her beloved pets, she goes back inside
                 the house to prepare her breakfast. She takes time to eat and relax
                 on Sundays because she knows how she is always in a hurry on the
                 other days of the week. When evening comes, it is time to prepare
                 for another week ahead. Despite the challenges she faces from
                 Monday to Saturday, she manages to survive because she knows
                 she can always have her Sundays to look forward to.
             </p>

             <div class="mt-3">
                 <div class="mb-3">
                     <label for="">Main Idea</label>
                     <input type="text" class="form-control">
                 </div>
                 <div class="mb-3">
                     <label for="">Supporting Details</label>

                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                 </div>
             </div>
         </div>
     </div>

 </section>


 <section id="fourthPart" class="d-none">
     <div class="">

         <div class="card custom-card m-auto p-3 mb-3">
             <p class=""><strong>Directions:</strong> Identify the main idea and at least three of its supporting details in
                 the paragraphs below. Write your answers below the paragraphs.
             </p>
             <img src="assets/images/bedtime.jpg" alt="" class="custom-image">
             <p class="mt-3">
                 Storytelling is an important activity. It can be entertaining and
                 educational at the same time. We tell our younger siblings some
                 stories to help them go to sleep. We tell stories to our friends and
                 family when we get together. We also use stories to teach valuable
                 lessons in life. We use stories to make sense of our world and to
                 share that understanding with others (Rose, 2011). We may not
                 notice it, but the stories we heard while we were growing up had a
                 huge impact on who we are and what we believe in.
             </p>

             <div class="mt-3">
                 <div class="mb-3">
                     <label for="">Main Idea</label>
                     <input type="text" class="form-control">
                 </div>
                 <div class="mb-3">
                     <label for="">Supporting Details</label>

                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon1">@</span>
                         <input type="text" class="form-control">
                     </div>
                 </div>
             </div>
         </div>
     </div>

 </section>