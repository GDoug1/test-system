import '../styles/ConfirmationModal.css';

function ConfirmationModal({ isOpen, title, message, onConfirm, onCancel, confirmText = 'Yes', cancelText = 'No' }) {
  if (!isOpen) return null;

  return (
    <div className="confirmation-overlay">
      <div className="confirmation-modal">
        <div className="confirmation-header">
          <h2>{title}</h2>
        </div>
        <div className="confirmation-body">
          <p>{message}</p>
        </div>
        <div className="confirmation-footer">
          <button type="button" className="confirmation-btn cancel-btn" onClick={onCancel}>
            {cancelText}
          </button>
          <button type="button" className="confirmation-btn confirm-btn" onClick={onConfirm}>
            {confirmText}
          </button>
        </div>
      </div>
    </div>
  );
}

export default ConfirmationModal;
