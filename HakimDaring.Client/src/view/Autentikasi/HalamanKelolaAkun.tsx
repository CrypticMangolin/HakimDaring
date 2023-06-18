class AccountManagement {
    private email: string;
    private username: string;
    private password: string;
  
    constructor(email: string, username: string, password: string) {
      this.email = email;
      this.username = username;
      this.password = password;
    }
  
    getEmail(): string {
      return this.email;
    }
  
    setEmail(email: string): void {
      this.email = email;
    }
  
    getUsername(): string {
      return this.username;
    }
  
    setUsername(username: string): void {
      this.username = username;
    }
  
    getPassword(): string {
      return this.password;
    }
  
    setPassword(password: string): void {
      this.password = password;
    }
  }
  
  // Contoh penggunaan
  const account = new AccountManagement("user@example.com", "myusername", "mypassword");
  
  // Mengubah email
  account.setEmail("newuser@example.com");
  
  // Mengubah username
  account.setUsername("newusername");
  
  // Mengubah password
  account.setPassword("newpassword");
  
  // Mendapatkan informasi akun
  console.log("Email:", account.getEmail());
  console.log("Username:", account.getUsername());
  console.log("Password:", account.getPassword());
  