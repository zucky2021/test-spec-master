import { LabelHTMLAttributes, ReactElement } from "react";

export default function InputLabel({
  value,
  className = "",
  children,
  ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }): ReactElement {
  return (
    <label
      {...props}
      className={`block font-medium text-sm text-gray-700 ` + className}
    >
      {value ? value : children}
    </label>
  );
}
