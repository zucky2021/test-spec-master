import { HTMLAttributes, ReactElement } from "react";

export default function InputError({
  message,
  className = "",
  ...props
}: HTMLAttributes<HTMLParagraphElement> & {
  message?: string;
}): ReactElement | null {
  return message ? (
    <p {...props} className={"text-sm text-red-600 " + className}>
      {message}
    </p>
  ) : null;
}
