/*---------------------------
  Avatar Preview with Loader
---------------------------*/
function handleAvatarPreview() {
  $("#avatar, #updateAvatar").on("change", function () {
    const targetImage =
      this.id === "avatar"
        ? "#avatarPreviewImage"
        : "#updateAvatarPreviewImage";
    const loader =
      this.id === "avatar" ? "#avatarLoader" : "#updateAvatarLoader";
    previewImageWithLoader(this, targetImage, loader);
  });
}

function previewImageWithLoader(input, targetSelector, loaderSelector) {
  const file = input.files[0];
  const targetImage = $(targetSelector);
  const loader = $(loaderSelector);

  if (file) {
    const reader = new FileReader();

    loader.removeClass("d-none").addClass("d-flex");

    reader.onload = function (e) {
      setTimeout(() => {
        targetImage.attr("src", e.target.result);
        loader.removeClass("d-flex").addClass("d-none");
      }, 2000);
    };

    reader.readAsDataURL(file);
  } else {
    targetImage.attr("src", "../../files/uploads/avatars/default-avatar.jpg");
    loader.removeClass("d-flex").addClass("d-none");
  }
}
