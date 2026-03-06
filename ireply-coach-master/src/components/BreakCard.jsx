import '../styles/BreakCard.css';

function BreakCard() {
  return (
    <div className="card break-card">
      <div className="card-top compact">
        <span>Break</span>
        <span className="toggle-wrap">Auto-Stop <span className="toggle-dot">●</span></span>
      </div>
      <button type="button" className="start-btn">Start</button>
    </div>
  );
}

export default BreakCard;
