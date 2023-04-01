const buttons = document.querySelectorAll('.getBioGraphy');
buttons.forEach(button => {
  button.addEventListener('click', () => {

    const userId = button.getAttribute('data-id');

    fetch(cusPublicBaseUrl.baseUrl + 'cub-get-users/v1/user/biography/' + userId)
      .then((response) => response.json())
      .then(data => {

        // Get the parent element where you want to append the new element
        const biographyElement = document.getElementById("biography-" + userId);

        // Remove existing appended element
        while (biographyElement.firstChild) {
          biographyElement.removeChild(biographyElement.firstChild);
        }

        // Append the new element to the parent element
        biographyElement.insertAdjacentHTML("beforeend", data.biography);
      })
      .catch(error => {
        console.error(error);
      });
  });
});