import { ApiUser } from './jwt';
import { Spectacle } from './spectacles';

export interface Shop {
  id: number;
  name: string;
  url?: string | null;
  owner?: ApiUser;
  spectacles: Spectacle[];
}
