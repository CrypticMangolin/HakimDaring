import { useEffect, useState } from 'react'
import { Navbar, Container, Nav, Dropdown, Button } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom'

function Header() {

  const navigate = useNavigate()

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

  return ( 
    <>
      <Navbar variant="light" bg="light" expand="lg">
        <Container>
          <Navbar.Brand href="/jelajah" className='fs-4 fw-bold'>Hakim Daring</Navbar.Brand>
          {namaPengguna != null &&
            <>
              <Nav className="ms-auto">
                <Dropdown align="end" id="basic-nav-dropdown">
                  <Dropdown.Toggle variant="light" id="dropdown-basic" className='px-2 text-end border border-dark rounded-3' style={{ width : "128px" }}>
                    {namaPengguna}
                  </Dropdown.Toggle>
                  <Dropdown.Menu>
                    <Dropdown.Item href="#action/3.1">
                      Kelola Akun
                    </Dropdown.Item>
                    <Dropdown.Divider />
                    <Dropdown.Item href="#action/3.4">
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