import '../styles/HolidayCard.css';

function HolidayCard({ holidayBirthdayItems }) {
  return (
    <div className="card holiday-card">
      <div className="card-top">
        <span>Holidays/Birthday</span>
        <span className="plus">+</span>
      </div>
      <ul className="list-items holiday-list">
        {holidayBirthdayItems.map((item) => (
          <li key={`${item.kind}-${item.label}`} className="holiday-item">
            <span className={`holiday-kind ${item.kind.toLowerCase()}`}>{item.kind}</span>
            <span className="holiday-label">{item.label}</span>
            <span className="holiday-date">{item.date}</span>
          </li>
        ))}
      </ul>
      <div className="mini-actions">✎&nbsp;&nbsp;◷</div>
    </div>
  );
}

export default HolidayCard;
