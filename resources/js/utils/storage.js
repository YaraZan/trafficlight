import { EncryptStorage } from 'encrypt-storage';

const SECRET = import.meta.env.VITE_SECRET_STORAGE

export const encryptStorage = new EncryptStorage(SECRET);
