const slide = new Slide('.slide', '.slide-wrapper');
slide.init();

class Gallery {
  constructor() {
    this.gallery = document.querySelector("[data-gallery='gallery']");
    this.galleryList = document.querySelectorAll("[data-gallery='list']");
    this.galleryMain = document.querySelector("[data-gallery='main']");

    this.chageImage = this.chageImage.bind(this);
  }

  chageImage({ currentTarget }) {
    this.galleryMain.src = currentTarget.src;
  }

  addChangeEvent() {
    this.galleryList.forEach((img) => {
      img.addEventListener('click', this.chageImage);
    });
  }

  init() {
    if (this.gallery) {
      this.addChangeEvent();
    }
  }
}

const gallery = new Gallery();
gallery.init();
