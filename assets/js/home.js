document.addEventListener('DOMContentLoaded', () => {
  const mainSlide = document.querySelector('.main-slide');
  const leftSlide = document.querySelector('.side-slide.left');
  const rightSlide = document.querySelector('.side-slide.right');
  const btnLeft = document.querySelector('.slider-arrow.left');
  const btnRight = document.querySelector('.slider-arrow.right');

  function swapSlides(direction) {
    // Lưu lại src ảnh hiện tại
    const mainSrc = mainSlide.src;
    const leftSrc = leftSlide.src;
    const rightSrc = rightSlide.src;

    if (direction === 'left') {
      mainSlide.src = leftSrc;
      leftSlide.src = rightSrc;
      rightSlide.src = mainSrc;
    } else if (direction === 'right') {
      mainSlide.src = rightSrc;
      rightSlide.src = leftSrc;
      leftSlide.src = mainSrc;
    }

    // Cập nhật class và style nếu cần (ví dụ thay đổi kích thước)
    resizeSlides();
  }

  function resizeSlides() {
    // Cho main-slide kích thước lớn, side nhỏ
    mainSlide.style.width = '100%';
    mainSlide.style.height = 'auto';

    leftSlide.style.width = '150px';
    leftSlide.style.height = 'auto';

    rightSlide.style.width = '150px';
    rightSlide.style.height = 'auto';
  }

  btnLeft.addEventListener('click', () => swapSlides('left'));
  btnRight.addEventListener('click', () => swapSlides('right'));

  resizeSlides(); // Gọi để đảm bảo kích thước ngay từ đầu
});