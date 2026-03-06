import '../styles/AnnouncementCard.css';

function AnnouncementCard({ announcements }) {
  return (
    <div className="card announcement-card">
      <div className="card-top">
        <span>Announcement</span>
        <button type="button" className="pill-btn">+ Announcement</button>
      </div>
      <ul className="list-items announcement-list">
        {announcements.map((item) => (
          <li key={item.title} className="announcement-item">
            <span className={`announcement-tag ${item.type.toLowerCase()}`}>{item.type}</span>
            <div className="announcement-copy">
              <div className="announcement-title">{item.title}</div>
              <div className="announcement-meta">{item.meta}</div>
            </div>
          </li>
        ))}
      </ul>
      <div className="mini-actions">✎&nbsp;&nbsp;◷</div>
    </div>
  );
}

export default AnnouncementCard;
