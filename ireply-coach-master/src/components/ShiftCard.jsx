import '../styles/ShiftCard.css';

function ShiftCard() {
  return (
    <div className="card shift-card">
      <div className="shift-columns">
        <div>
          <div className="label">Shift Start Time</div>
          <div className="value">9:00 AM</div>
        </div>
        <div>
          <div className="label">Shift Start End</div>
          <div className="value">6:00 PM</div>
        </div>
      </div>
      <div className="remaining">8 hrs Remaining Time</div>
    </div>
  );
}

export default ShiftCard;
