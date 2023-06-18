import { useEffect, useState } from 'react'
import { Navbar, Container, Nav, Dropdown, Button } from 'react-bootstrap'
import { useLocation, useNavigate } from 'react-router-dom'
import RequestKeluar from '../core/Autentikasi/RequestKeluar'

function Header() {

  const navigate = useNavigate()
  const location = useLocation()
  const isProfilePage = location.pathname === '/profile'

  const requestKeluar : RequestKeluar = new RequestKeluar()

  let [namaPengguna, setNamaPengguna] = useState<string|null>(null)

  useEffect(() => {
    const pengambilNama = () => {
      setNamaPengguna(localStorage.getItem("nama"))
    }

    pengambilNama()
  })

  const pindahHalamanMasuk = () => {
    navigate("/masuk")
  }

  const keluarAkun = () => {
    localStorage.setItem("role", "")
    requestKeluar.execute(() => {
      navigate("/")
    })
  }

  const kelolaAkun = () => {
    navigate("/profile")
  }

  const Dashboard = () => {
    navigate("/jelajah")
  }

  return ( 
    <>
      <Navbar variant="light" bg="light" expand="lg">
        <Container>
          <Navbar.Brand href="/jelajah" className='fs-4 fw-bold'>Hakim Daring</Navbar.Brand>
          { 'admin' == localStorage.getItem("role") && <p>Admin</p>}
          {namaPengguna != null &&
            <>
              <Nav className="ms-auto">
                <Dropdown align="end" id="basic-nav-dropdown">
                  <Dropdown.Toggle variant="light" id="dropdown-basic" className='px-2 text-end border border-dark rounded-3' style={{ width : "128px" }}>
                    {namaPengguna}
                  </Dropdown.Toggle>
                  <Dropdown.Menu>
                    {isProfilePage ? 
                      <Dropdown.Item onClick={Dashboard}>
                        Dashboard
                      </Dropdown.Item> 
                      :
                      <Dropdown.Item onClick={kelolaAkun}>
                        Kelola Akun
                      </Dropdown.Item>                       
                    }
                    <Dropdown.Divider />
                    <Dropdown.Item onClick={keluarAkun}>
                      Keluar
                    </Dropdown.Item>
                  </Dropdown.Menu>
                </Dropdown>
              </Nav>
            </>
          }
          {namaPengguna == null &&
            <Button variant='dark' className='px-3 rounded-pill fs-6' onClick={pindahHalamanMasuk}>Masuk</Button>
          }
        </Container>
      </Navbar>
      <hr className='m-0 p-0'></hr>
    </>
  )
}

export default Header