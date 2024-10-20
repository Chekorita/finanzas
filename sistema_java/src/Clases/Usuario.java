package Clases;

public class Usuario {
	private int id;
	private String nombre_user;
	private String acceso;
	private String random;
	private String paterno;
	private String materno;
	private String nombre;
	private float ingreso_mensual;
	private int estado;

	public Usuario() {}

	public Usuario(int id, String nombre_user, String acceso, String random, String paterno, String materno,
			String nombre, float ingreso_mensual, int estado) {
		this.id = id;
		this.nombre_user = nombre_user;
		this.acceso = acceso;
		this.random = random;
		this.paterno = paterno;
		this.materno = materno;
		this.nombre = nombre;
		this.ingreso_mensual = ingreso_mensual;
		this.estado = estado;
	}

	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getNombre_user() {
		return nombre_user;
	}
	public void setNombre_user(String nombre_user) {
		this.nombre_user = nombre_user;
	}
	public String getAcceso() {
		return acceso;
	}
	public void setAcceso(String acceso) {
		this.acceso = acceso;
	}
	public String getRandom() {
		return random;
	}
	public void setRandom(String random) {
		this.random = random;
	}
	public String getPaterno() {
		return paterno;
	}
	public void setPaterno(String paterno) {
		this.paterno = paterno;
	}
	public String getMaterno() {
		return materno;
	}
	public void setMaterno(String materno) {
		this.materno = materno;
	}
	public String getNombre() {
		return nombre;
	}
	public void setNombre(String nombre) {
		this.nombre = nombre;
	}
	public float getIngreso_mensual() {
		return ingreso_mensual;
	}
	public void setIngreso_mensual(float ingreso_mensual) {
		this.ingreso_mensual = ingreso_mensual;
	}
	public int getEstado() {
		return estado;
	}
	public void setEstado(int estado) {
		this.estado = estado;
	}
}
