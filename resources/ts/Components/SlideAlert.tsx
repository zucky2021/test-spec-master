import React, { useEffect, useRef } from "react";
import "@scss/components/slide_alert.scss";

type Props = {
  isShow: boolean;
  children: React.ReactNode;
};

const SlideAlert: React.FC<Props> = ({ isShow, children }) => {
  const dialogRef = useRef<HTMLDialogElement>(null);

  useEffect(() => {
    if (isShow && dialogRef.current) {
      dialogRef.current.show();
    } else if (!isShow && dialogRef.current) {
      dialogRef.current.close();
    }
  }, [isShow]);

  return (
    <dialog
      ref={dialogRef}
      className={`slide-alert ${isShow ? "slide-alert--show" : ""}`}
    >
      {children}
    </dialog>
  );
};

export default SlideAlert;
