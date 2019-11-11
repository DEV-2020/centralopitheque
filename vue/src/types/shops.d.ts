import { ApiUser } from './jwt';

export interface Shop {
  id: number;
  name: string;
  url?: string | null;
  owner: ApiUser;
  // @todo change type later
  spectacles: any[];
}
