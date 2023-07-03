using Microsoft.AspNetCore.Mvc;
using WebApp.Services;

namespace WebApp
{
    public class ContactData
    {
        public string Nom { get; set; }
        public  string Email { get; set; }
        public string Message { get; set; }
    }

    public class ContactController : Controller
    {
        private readonly IEmailService _emailService;

        public ContactController(IEmailService emailService)
        {
            _emailService = emailService;
        }

        [HttpPost]
        [Route("/ContactController/Submit")]
        public async Task<IActionResult> Submit(ContactData contactData)
        {
            // Utilisez les données du formulaire à partir de l'objet ContactData
            
            // Envoi de l'email
            await _emailService.SendEmailAsync("bontahzno@gmail.com", contactData.Nom, contactData.Message);

            // Redirection vers une page de confirmation
            return RedirectToAction("Confirmation");
        }

        public IActionResult Confirmation()
        {
            // Afficher une page de confirmation
            return View();
        }
    }
}
