import '../styles/SummaryCard.css';

function SummaryCard({ timeInStart, totalHours }) {
  return (
    <div className="card summary-card">
      <div>
        <div className="label">Today Status</div>
        <div className="small-info">Time In: {timeInStart ? timeInStart.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' }) : '--:--'}</div>
        <div className="small-info">Break: Inactive</div>
      </div>
      <div>
        <div className="label">Total Hours</div>
        <div className="big-value">{totalHours}h</div>
      </div>
      <div>
        <div className="label">Attendance</div>
        <div className="big-value">{timeInStart ? 'Present' : 'Absent'}</div>
      </div>
    </div>
  );
}

export default SummaryCard;
