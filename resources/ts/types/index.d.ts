export type User = {
  id: number;
  department_id: number | string;
  name: string;
  email: string;
  email_verified_at: string;
  is_admin: boolean;
};

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
  auth: {
    user: User;
  };
};
