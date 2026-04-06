import React, { useMemo, useState } from 'react';
import '../styles/gallery-portal.css';

const heroImage = '/wamdevin-full/assets/images/banner/banner1.jpg';

const galleryItems = [
  { src: '/wamdevin-full/assets/images/gallery/pic1.jpg', title: 'Regional Policy Dialogue', category: 'Events' },
  { src: '/wamdevin-full/assets/images/gallery/pic2.jpg', title: 'Leadership Workshop', category: 'Training' },
  { src: '/wamdevin-full/assets/images/gallery/pic3.jpg', title: 'Institutional Collaboration', category: 'Partnerships' },
  { src: '/wamdevin-full/assets/images/gallery/pic4.jpg', title: 'Public Sector Capacity Building', category: 'Training' },
  { src: '/wamdevin-full/assets/images/gallery/pic5.jpg', title: 'Executive Roundtable', category: 'Events' },
  { src: '/wamdevin-full/assets/images/gallery/pic6.jpg', title: 'Knowledge Exchange Session', category: 'Research' },
  { src: '/wamdevin-full/assets/images/gallery/pic7.jpg', title: 'Technical Advisory Forum', category: 'Consultancy' },
  { src: '/wamdevin-full/assets/images/gallery/pic8.jpg', title: 'Member Institutions Meeting', category: 'Partnerships' },
  { src: '/wamdevin-full/assets/images/gallery/pic9.jpg', title: 'Regional Leadership Summit', category: 'Events' },
  { src: '/wamdevin-full/img/about.jpg', title: 'WAMDEVIN Legacy Moments', category: 'Archive' },
  { src: '/wamdevin-full/img/feature.jpg', title: 'Program Highlights', category: 'Archive' },
  { src: '/wamdevin-full/img/header.jpg', title: 'Institutional Growth Story', category: 'Archive' }
];

const categories = ['All', 'Events', 'Training', 'Partnerships', 'Research', 'Consultancy', 'Archive'];

function GalleryPortal() {
  const [activeCategory, setActiveCategory] = useState('All');
  const [selectedItem, setSelectedItem] = useState(null);

  const filteredItems = useMemo(() => {
    if (activeCategory === 'All') {
      return galleryItems;
    }

    return galleryItems.filter((item) => item.category === activeCategory);
  }, [activeCategory]);

  return (
    <section className="gallery-page">
      <div className="gallery-hero" style={{ backgroundImage: `linear-gradient(120deg, rgba(11, 47, 91, 0.92), rgba(15, 77, 146, 0.82)), url(${heroImage})` }}>
        <div className="gallery-hero-content">
          <p className="gallery-eyebrow">WAMDEVIN Visual Archive</p>
          <h1>Gallery of Regional Impact</h1>
          <p>
            A branded showcase of leadership development, research collaboration, training excellence, and institutional partnerships across West Africa.
          </p>
        </div>
      </div>

      <div className="gallery-shell">
        <div className="gallery-toolbar">
          {categories.map((category) => (
            <button
              key={category}
              type="button"
              className={`gallery-filter ${activeCategory === category ? 'active' : ''}`}
              onClick={() => setActiveCategory(category)}
            >
              {category}
            </button>
          ))}
        </div>

        <div className="gallery-grid">
          {filteredItems.map((item) => (
            <button
              key={`${item.src}-${item.title}`}
              type="button"
              className="gallery-card"
              onClick={() => setSelectedItem(item)}
            >
              <img
                src={item.src}
                alt={item.title}
                onError={(e) => {
                  e.currentTarget.src = '/wamdevin-full/img/feature.jpg';
                }}
              />
              <span className="gallery-card-category">{item.category}</span>
              <div className="gallery-card-copy">
                <h3>{item.title}</h3>
              </div>
            </button>
          ))}
        </div>

        {filteredItems.length === 0 && (
          <p className="gallery-empty">No gallery items in this category yet.</p>
        )}
      </div>

      {selectedItem && (
        <div className="gallery-lightbox" role="dialog" aria-modal="true" onClick={() => setSelectedItem(null)}>
          <div className="gallery-lightbox-inner" onClick={(e) => e.stopPropagation()}>
            <button type="button" className="gallery-close" onClick={() => setSelectedItem(null)} aria-label="Close image preview">
              x
            </button>
            <img
              src={selectedItem.src}
              alt={selectedItem.title}
              onError={(e) => {
                e.currentTarget.src = '/wamdevin-full/img/feature.jpg';
              }}
            />
            <div className="gallery-lightbox-meta">
              <h2>{selectedItem.title}</h2>
              <p>{selectedItem.category}</p>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}

export default GalleryPortal;
