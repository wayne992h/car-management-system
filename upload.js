document.addEventListener("DOMContentLoaded", function () {
    const addImageButton = document.getElementById("add-image");
    const deleteImageButton = document.getElementById("delete-image");
  
    // Add image
    addImageButton.addEventListener("click", function () {
      const input = document.createElement("input");
      input.type = "file";
      input.accept = "image/*";
      input.click();
  
      input.addEventListener("change", function () {
        const formData = new FormData();
        formData.append("image", input.files[0]);
  
        fetch("imageHandler.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((fileName) => {
            if (fileName) {
              const image = document.createElement("img");
              image.src = "image/" + fileName;
              image.classList.add("uploaded-image");
              document.getElementById("image-area").appendChild(image);
            } else {
              alert("Failed to upload image.");
            }
          });
      });
    });
  
    //Delete image
    deleteImageButton.addEventListener("click", function () {
      const images = document.querySelectorAll(".uploaded-image");
      images.forEach((image) => {
        if (image.classList.contains("selected")) {
          const fileName = image.src.split("/").pop();
  
          fetch("imageHandler.php?delete=" + fileName, {
            method: "DELETE",
          })
            .then((response) => response.text())
            .then((result) => {
              if (result === "success") {
                image.remove();
              } else {
                alert("Failed to delete image.");
              }
            });
        }
      });
    });

    //Load existing images
    function loadExistingImages() {
        fetch("imageHandler.php?fetch=existing")
          .then((response) => response.json())
          .then((fileNames) => {
            fileNames.forEach((fileName) => {
              const image = document.createElement("img");
              image.src = "image/" + fileName;
              image.classList.add("uploaded-image");
              document.getElementById("image-area").appendChild(image);
            });
          });
      }
      
      // Call the function to load existing images
      loadExistingImages();
  
    document
      .getElementById("image-area")
      .addEventListener("click", function (event) {
        if (event.target.tagName === "IMG") {
          event.target.classList.toggle("selected");
        }
      });
  });
  